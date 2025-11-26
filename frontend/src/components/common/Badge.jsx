import './Badge.css';

const Badge = ({ children, variant = 'primary', icon = null, className = '' }) => {
  return (
    <span className={`badge badge-${variant} ${className}`}>
      {icon && <span className="badge-icon">{icon}</span>}
      {children}
    </span>
  );
};

export default Badge;