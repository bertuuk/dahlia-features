const { render } = wp.element; // React
const { Button } = wp.components;
const { __ } = wp.i18n; // Traducciones

const IconSelector = ({ value, onChange, iconList }) => {
    return (
        <div className="icon-selector">
            {iconList.map((icon) => (
                <button
                    key={icon}
                    className={`icon-button ${value === icon ? 'selected' : ''}`}
                    onClick={() => onChange(icon)}
                    aria-label={icon.replace('dahlia-', '').replace(/-/g, ' ')}
                >
                    <i className={`dahlia-icon dahlia-${icon}`} aria-hidden="true"></i>
                </button>
            ))}
        </div>
    );
};


// Inicializar el componente React
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('dahlia-category-icon-selector');
    if (container) {
        const { termId, icon } = container.dataset;
        const iconList = Array.isArray(dahliaFeatures.icons)
        ? dahliaFeatures.icons
        : Object.values(dahliaFeatures.icons);


        render(
            <IconSelector
                value={icon}
                onChange={(newValue) => {
                    document.querySelector('input#dahlia-category-icon').value = newValue;
                }}
                iconList={iconList}
            />,
            container
        );
    }
});
