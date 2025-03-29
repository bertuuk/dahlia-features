import { createRoot } from 'react-dom/client';
import { useState, useEffect } from '@wordpress/element'; 
import { __ } from '@wordpress/i18n';
/**
 * MediaSelector Component
 *
 * This component provides a reusable image selection field using WordPress's Media Library.
 * It allows selecting, previewing, and removing an image.
 *
 * Props:
 * - label: Label text for the field.
 * - value: The current value (image ID) of the field.
 * - onChange: Callback to handle when the value changes.
 */
const MediaSelector = ({ label, value, onChange }) => {
    const [preview, setPreview] = useState(dahliaFeatures.imagePreview || '');
 
    const openMediaLibrary = () => {
        const mediaUploader = wp.media({
            title: __('Select Image', 'dahlia-features'),
            button: {
                text: __('Use this image', 'dahlia-features'),
            },
            multiple: false,
        });

        mediaUploader.on('select', () => {
            const attachment = mediaUploader.state().get('selection').first().toJSON();
            setPreview(attachment.url);
            onChange(attachment.id);
        });

        mediaUploader.open();
    };

    const removeImage = () => {
        setPreview('');
        onChange(null);
    };

    return (
        <div className="media-selector">
            <label>{label}</label>
            <div className="media-selector-preview" style={{ marginBottom: '10px' }}>
                {preview ? <img src={preview} alt="" style={{ maxWidth: '150px', height: 'auto' }} /> : <p>{__('No image selected', 'dahlia-features')}</p>}
            </div>
            <button type="button" className="button" onClick={openMediaLibrary}>
                {__('Select Image', 'dahlia-features')}
            </button>
            {preview && (
                <button type="button" className="button" onClick={removeImage} style={{ marginLeft: '10px' }}>
                    {__('Remove Image', 'dahlia-features')}
                </button>
            )}
        </div>
    );
};

export default MediaSelector;


document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('dahlia-category-image-selector');
    if (container) {
        const root = createRoot(container);
        const initialValue = container.dataset.value || ''; // Obtener el valor inicial
        root.render(
            <MediaSelector
                label={__('Category Image', 'dahlia-features')}
                value={initialValue}
                onChange={(newValue) => {
                    document.getElementById('dahlia-category-image').value = newValue || '';
                }}
            />,
            container
        );
    }
});