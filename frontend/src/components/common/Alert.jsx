import './Alert.css';

const Alert = ({ type = 'info', title, message, onClose, className = '' }) => {
  const icons = {
    info: 'ℹ️',
    success: '✓',
    warning: '⚠️',
    error: '✕',
  };

  return (
    <div className={`alert alert-${type} ${className}`}>
      <div className="alert-icon">{icons[type]}</div>

      <div className="alert-content">
        {title && <div className="alert-title">{title}</div>}
        <div className="alert-message">{message}</div>
      </div>

      {onClose && (
        <button className="alert-close" onClick={onClose} aria-label="Close alert">
          ✕
        </button>
      )}
    </div>
  );
};

export default Alert;