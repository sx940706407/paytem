import { warn, isCallable, isObject, merge, getPath, isNullOrUndefined } from '../utils';

// @flow

const normalizeValue = (value: any) => {
  if (isObject(value)) {
    return Object.keys(value).reduce((prev, key) => {
      prev[key] = normalizeValue(value[key]);

      return prev;
    }, {});
  }

  if (isCallable(value)) {
    return value('{0}', ['{1}', '{2}', '{3}']);
  }

  return value;
};

const normalizeFormat = (locale: Locale) => {
  // normalize messages
  const dictionary = {};
  if (locale.messages) {
    dictionary.messages = normalizeValue(locale.messages);
  }

  if (locale.custom) {
    dictionary.custom = normalizeValue(locale.custom);
  }

  if (locale.attributes) {
    dictionary.attributes = locale.attributes;
  }

  if (!isNullOrUndefined(locale.dateFormat)) {
    dictionary.dateFormat = locale.dateFormat;
  }

  return dictionary;
};

export default class I18nDictionary implements IDictionary {
  rootKey: string;
  i18n: Object;

  constructor (i18n: Object, rootKey: string) {
    this.i18n = i18n;
    this.rootKey = rootKey;
  }

  get locale (): string {
    return this.i18n.locale;
  }

  set locale (value: string) {
    warn('Cannot set locale from the validator when using vue-i18n, use i18n.locale setter instead');
  }

  getDateFormat (locale: string): string {
    return this.i18n.getDateTimeFormat(locale || this.locale);
  }

  setDateFormat (locale: string, value: string) {
    this.i18n.setDateTimeFormat(locale || this.locale, value);
  }

  getMessage (_, key: string, data: any[]): string {
    const path = `${this.rootKey}.messages.${key}`;
    const result = this.i18n.t(path, data);
    if (result !== path) {
      return result;
    }

    return this.i18n.t(`${this.rootKey}.messages._default`, data);
  }

  getAttribute (_, key: string, fallback?: string = ''): string {
    const path = `${this.rootKey}.attributes.${key}`;
    const result = this.i18n.t(path);
    if (result !== path) {
      return result;
    }

    return fallback;
  }

  getFieldMessage (_, field: string, key: string, data: any[]) {
    const path = `${this.rootKey}.custom.${field}.${key}`;
    const result = this.i18n.t(path, data);
    if (result !== path) {
      return result;
    }

    return this.getMessage(_, key, data);
  }

  merge (dictionary) {
    Object.keys(dictionary).forEach(localeKey => {
      // i18n doesn't deep merge
      // first clone the existing locale (avoid mutations to locale)
      const clone = merge({}, getPath(`${localeKey}.${this.rootKey}`, this.i18n.messages, {}));
      // Merge cloned locale with new one
      const locale = merge(clone, normalizeFormat(dictionary[localeKey]));
      this.i18n.mergeLocaleMessage(localeKey, { [this.rootKey]: locale });
      if (locale.dateFormat) {
        this.i18n.setDateTimeFormat(localeKey, locale.dateFormat);
      }
    });
  }

  setMessage (locale: string, key: string, value: () => string | string) {
    this.merge({
      [locale]: {
        messages: {
          [key]: value
        }
      }
    });
  }

  setAttribute (locale: string, key: string, value: string) {
    this.merge({
      [locale]: {
        attributes: {
          [key]: value
        }
      }
    });
  }
};
