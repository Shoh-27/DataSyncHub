import './Button.css';

const Button = ({
  children,
  onClick,
  type = 'button',
  variant = 'primary',
  size = 'md',
  disabled = false,
  loading = false,
  icon = null,
  className = '',
  ...props
}) => {
  const buttonClass = `btn btn-${variant} btn-${size} ${loading ? 'loading' : ''} ${className}`;

  return (
    <button
      type={type}
      onClick={onClick}
      disabled={disabled || loading}
      className={buttonClass}
      {...props}
    >
      {icon && <span className="btn-icon">{icon}</span>}
      {loading ? 'Loading...' : children}
    </button>
  );
};

export default Button;