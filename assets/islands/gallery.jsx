import { createRoot } from 'react-dom/client';
import Lightbox from '../react/Lightbox.jsx';

const root = document.getElementById('lightbox-root');
if (root) {
    createRoot(root).render(<Lightbox imageSelector=".project-card__images img" />);
}
