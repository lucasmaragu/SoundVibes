

 const fetchRadio = async () => { 
    try {
        const response = await fetch('http://172.17.131.175:3000/api/radios');
        if (!response.ok) {
            throw new Error('Failed to fetch radio');
        }
        return await response.json();
    } catch (error) {
        console.error('Failed to fetch radio', error);
    }}

    export default fetchRadio;