import { useState } from 'react';
import './Input.css';

const Input = ({
  label,
  type = 'text',
  name,
  value,
  onChange,
  placeholder,
  ...props
}) => {
  return (
    
      label && (
        <label htmlFor={name} className="input-label">
          {label}
          {required && <span className="text-error"> *</span>}
        </label>
      )

   
  );
};

export default Input;
