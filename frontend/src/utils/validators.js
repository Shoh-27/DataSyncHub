
export const isValidEmail = email => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  };
  
  export const isValidPassword = password => {
    // At least 8 characters, 1 uppercase, 1 number, 1 special character
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    return passwordRegex.test(password);
  };
  
  export const validateRequired = value => {
    if (typeof value === 'string') {
      return value.trim().length > 0;
    }
    return value !== null && value !== undefined;
  };
  
  export const validateMinLength = (value, minLength) => {
    return value.length >= minLength;
  };
  
  export const validateMaxLength = (value, maxLength) => {
    return value.length <= maxLength;
  };
  
  export const validateUrl = url => {
    try {
      new URL(url);
      return true;
    } catch {
      return false;
    }
  };
  
  export const validateNumber = value => {
    return !isNaN(parseFloat(value)) && isFinite(value);
  };
  
  export const validatePositiveNumber = value => {
    return validateNumber(value) && parseFloat(value) > 0;
  };
  
  export const getPasswordStrength = password => {
    let strength = 0;
  
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[@$!%*?&]/.test(password)) strength++;
  
    if (strength <= 2) return { level: 'weak', color: 'var(--color-error)' };
    if (strength <= 4) return { level: 'medium', color: 'var(--color-warning)' };
    return { level: 'strong', color: 'var(--color-success)' };
  };
  
  export const validateForm = (values, rules) => {
    const errors = {};
  
    Object.keys(rules).forEach(field => {
      const value = values[field];
      const fieldRules = rules[field];
  
      if (fieldRules.required && !validateRequired(value)) {
        errors[field] = fieldRules.requiredMessage || 'This field is required';
        return;
      }
  
      if (fieldRules.email && !isValidEmail(value)) {
        errors[field] = 'Please enter a valid email address';
        return;
      }
  
      if (fieldRules.password && !isValidPassword(value)) {
        errors[field] =
          'Password must be at least 8 characters with uppercase, number, and special character';
        return;
      }
  
      if (fieldRules.minLength && !validateMinLength(value, fieldRules.minLength)) {
        errors[field] = `Minimum length is ${fieldRules.minLength} characters`;
        return;
      }
  
      if (fieldRules.maxLength && !validateMaxLength(value, fieldRules.maxLength)) {
        errors[field] = `Maximum length is ${fieldRules.maxLength} characters`;
        return;
      }
  
      if (fieldRules.url && value && !validateUrl(value)) {
        errors[field] = 'Please enter a valid URL';
        return;
      }
  
      if (fieldRules.custom && !fieldRules.custom(value, values)) {
        errors[field] = fieldRules.customMessage || 'Invalid value';
      }
    });
  
    return errors;
  };