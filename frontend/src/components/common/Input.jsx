import { useState } from 'react';
import './Input.css';

const Input = ({
    label,
    type = 'text',
    name,
    value,
    onChange,
    placeholder,
    error,
    helper,
    required = false,
    disabled = false,
    icon = null,
    className = '',
    ...props
}) => {
    const [showPassword, setShowPassword] = useState(false);

    const inputType = type === 'password' && showPassword ? 'text' : type;
    return (
        <div className={`input-group ${className}`}>
            {label && (
                <label htmlFor={name} className="input-label">
                    {label}
                    {required && <span className="text-error"> *</span>}
                </label>
            )}

            <div className="input-wrapper">
                {icon && <span className="input-icon-left">{icon}</span>}

                <input
                    id={name}
                    name={name}
                    type={inputType}
                    value={value}
                    onChange={onChange}
                    placeholder={placeholder}
                    disabled={disabled}
                    required={required}
                    className={`input ${error ? 'input-error' : ''} ${icon ? 'input-with-icon' : ''}`}
                    {...props}
                />

                {type === 'password' && (
                    <button
                        type="button"
                        className="input-icon-right"
                        onClick={() => setShowPassword(!showPassword)}
                        tabIndex={-1}
                    >
                        {showPassword ? '👁️' : '👁️‍🗨️'}
                    </button>
                )}
            </div>

            {error && <span className="input-error-message">{error}</span>}
            {helper && !error && <span className="input-helper">{helper}</span>}
        </div>
    );
};

export default Input;
