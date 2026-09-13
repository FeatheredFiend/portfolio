import { useEffect, useState } from 'react';

export default function Lightbox({ imageSelector }) {
    const [active, setActive] = useState(null); // { src, alt } | null

    useEffect(() => {
        function handleClick(event) {
            const img = event.target.closest(imageSelector);
            if (!img) {
                return;
            }

            setActive({ src: img.src, alt: img.alt });
        }

        document.addEventListener('click', handleClick);
        return () => document.removeEventListener('click', handleClick);
    }, [imageSelector]);

    useEffect(() => {
        if (!active) {
            return;
        }

        document.body.style.overflow = 'hidden';

        function handleKeydown(event) {
            if (event.key === 'Escape') {
                setActive(null);
            }
        }

        document.addEventListener('keydown', handleKeydown);
        return () => {
            document.body.style.overflow = '';
            document.removeEventListener('keydown', handleKeydown);
        };
    }, [active]);

    if (!active) {
        return null;
    }

    return (
        <div className="lightbox" onClick={() => setActive(null)}>
            <button className="lightbox__close" type="button" aria-label="Close" onClick={() => setActive(null)}>
                &times;
            </button>
            <img className="lightbox__image" src={active.src} alt={active.alt} onClick={(event) => event.stopPropagation()} />
        </div>
    );
}
