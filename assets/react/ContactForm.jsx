import { useState } from 'react';

export default function ContactForm({ endpoint }) {
    const [values, setValues] = useState({ name: '', email: '', message: '' });
    const [fieldErrors, setFieldErrors] = useState({});
    const [status, setStatus] = useState('idle'); // idle | submitting | success | error

    function handleChange(event) {
        const { name, value } = event.target;
        setValues((prev) => ({ ...prev, [name]: value }));
    }

    async function handleSubmit(event) {
        event.preventDefault();
        setStatus('submitting');
        setFieldErrors({});

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                },
                body: JSON.stringify(values),
            });

            if (response.ok) {
                setStatus('success');
                setValues({ name: '', email: '', message: '' });
                return;
            }

            if (response.status === 422) {
                const problem = await response.json();
                const errors = {};
                for (const violation of problem.violations ?? []) {
                    errors[violation.propertyPath] = violation.title;
                }
                setFieldErrors(errors);
                setStatus('error');
                return;
            }

            setStatus('error');
        } catch {
            setStatus('error');
        }
    }

    if (status === 'success') {
        return <p className="contact-form__success">Thanks — your message is on its way. I'll get back to you soon.</p>;
    }

    return (
        <form className="contact-form" onSubmit={handleSubmit} noValidate>
            <div className="contact-form__field">
                <label htmlFor="contact-name">Name</label>
                <input
                    id="contact-name"
                    name="name"
                    type="text"
                    value={values.name}
                    onChange={handleChange}
                    required
                />
                {fieldErrors.name && <p className="contact-form__error">{fieldErrors.name}</p>}
            </div>

            <div className="contact-form__field">
                <label htmlFor="contact-email">Email</label>
                <input
                    id="contact-email"
                    name="email"
                    type="email"
                    value={values.email}
                    onChange={handleChange}
                    required
                />
                {fieldErrors.email && <p className="contact-form__error">{fieldErrors.email}</p>}
            </div>

            <div className="contact-form__field">
                <label htmlFor="contact-message">Message</label>
                <textarea
                    id="contact-message"
                    name="message"
                    rows={5}
                    value={values.message}
                    onChange={handleChange}
                    required
                />
                {fieldErrors.message && <p className="contact-form__error">{fieldErrors.message}</p>}
            </div>

            {status === 'error' && Object.keys(fieldErrors).length === 0 && (
                <p className="contact-form__error">Something went wrong sending that — please try again.</p>
            )}

            <button className="button button--primary" type="submit" disabled={status === 'submitting'}>
                {status === 'submitting' ? 'Sending…' : 'Send message'}
            </button>
        </form>
    );
}
