import axios from 'axios';

let config = {

    baseURL: '/api',
    headers: {
        'Content-Type': 'application/vnd.api+json',
    },
};

const transport = axios.create(config);

export default transport;
