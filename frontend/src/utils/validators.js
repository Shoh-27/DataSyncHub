
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
  
  