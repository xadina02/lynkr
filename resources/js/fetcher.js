export default async function fetcher(url, options = {}) {
    // const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const token = localStorage.getItem('lynkr_token');
    const tokenType = localStorage.getItem('lynkr_token_type') || 'Bearer';

    const defaultHeaders = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        // ...(token ? { 'X-CSRF-TOKEN': token } : {})
        ...options.defaultHeaders,
    };

    if (token) {
        defaultHeaders['Authorization'] = `${tokenType} ${token}`;
    }

    const response = await fetch(url, {
        headers: defaultHeaders,
        credentials: 'same-origin',
        ...options
    });

    if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        throw new Error(errorData.message || 'API request failed');
    }

    return await response.json();
}
