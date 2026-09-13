import { createRoot } from 'react-dom/client';
import ContactForm from '../react/ContactForm.jsx';

const root = document.getElementById('contact-form-root');
if (root) {
    createRoot(root).render(<ContactForm endpoint={root.dataset.endpoint} />);
}
