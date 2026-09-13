import './styles/app.css';
import { createRoot } from 'react-dom/client';
import ContactForm from './react/ContactForm.jsx';
import Lightbox from './react/Lightbox.jsx';

const contactRoot = document.getElementById('contact-form-root');
if (contactRoot) {
    createRoot(contactRoot).render(<ContactForm endpoint={contactRoot.dataset.endpoint} />);
}

const lightboxRoot = document.getElementById('lightbox-root');
if (lightboxRoot) {
    createRoot(lightboxRoot).render(<Lightbox imageSelector=".project-card__images img" />);
}
