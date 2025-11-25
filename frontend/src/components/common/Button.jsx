import './Button.css';

const Button = ({
  children,
  type = 'button',
  variant = 'primary',
  size = 'md',
  className = '',
  ...props
}) => {
  const buttonClass = `btn btn-${variant} btn-${size} ${loading ? 'loading' : ''} ${className}`;

  return (
    <button    >
      {icon && <span className="btn-icon">{icon}</span>}
      {loading ? 'Loading...' : children}
    </button>
  );
};

export default Button;