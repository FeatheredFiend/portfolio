import { useEffect, useState } from 'react';

export default function Lightbox({ imageSelector }) {
    const [active, setActive] = useState(null); // { src, alt } | null

    useEffect(() => {
        function handleClick(event) {
            const img = event.target.closest(imageSelector);
            if (!img) {
                return;
            }

            // data-full points at a larger version where there is one (the game screenshots).
            setActive({ src: img.dataset.full || img.currentSrc || img.src, alt: img.alt });
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
            <figure className="lightbox__figure" onClick={(event) => event.stopPropagation()}>
                <img className="lightbox__image" src={active.src} alt={active.alt} />
                {active.alt && <figcaption className="lightbox__caption">{active.alt}</figcaption>}
            </figure>
        </div>
    );
}
