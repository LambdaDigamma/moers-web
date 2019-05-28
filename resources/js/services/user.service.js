import axios from 'axios';

export const userService = {
    login,
    logout
};

function login(email, password) {

    const data = {
        email: email,
        password: password
    }

    return axios({
        method: 'POST',
        url: '/api/v2/auth/login',
        data: data,
        config: { headers: { 'Content-Type': 'application/json' } }
    })
        .then(response => {

            const data = response.data

            if (response.status !== 200) {

                if (response.status === 401) {
                    logout()
                    location.reload(true)
                }

                const error = (data && data.message) || response.statusText;
                return Promise.reject(error);

            }

            return response

        })
        .then(response => {

            let user = response.data
            let token = response.headers.authorization

            if (token) {

                user.token = token
                localStorage.setItem('user', JSON.stringify(user))

            }

            return user

        })

}

function logout() {

    return axios({
        method: 'POST',
        url: '/api/v2/auth/logout',
    }).then(response => {
        localStorage.removeItem('user');
    })

}