import './Card.css';

const Card = ({
  children,
  title,
  subtitle,
  footer,
  onClick,
  hoverable = false,
  className = '',
}) => {
  const cardClass = `card ${hoverable ? 'card-hoverable' : ''} ${className}`;

  return (
    <div className={cardClass} onClick={onClick}>
      {(title || subtitle) && (
        <div className="card-header">
          {title && <h3 className="card-title">{title}</h3>}
          {subtitle && <p className="card-subtitle">{subtitle}</p>}
        </div>
      )}

      <div className="card-body">{children}</div>

      {footer && <div className="card-footer">{footer}</div>}
    </div>
  );
};

export default Card;