import axios from 'axios'
import Config from './Config'

const Auth = {
    isAuthenticated: function() {           
        if(localStorage.getItem('user')) {
            return true
        } else if(localStorage.getItem('user') === 'undefined') {
            return false
        }
    },

    login: async () => {
        let data = {}
        await axios.post(Config.api('login'), {
            email: "admin@superadmin.com",
            password: "password"
        })
        .then(async (res) => {
            if(res.data === "") {
                localStorage.removeItem('user')
            } else {
                localStorage.setItem('user', JSON.stringify({
                    token: res.data.token
                }))                

                await axios.post(Config.api(`me?token=${JSON.parse(localStorage.getItem('user')).token}`))
                .then(async (res) => {
                    let latestToken = JSON.parse(localStorage.getItem('user'))
                    let result = res.data

                    result.token = latestToken.token
                    data = await result
                    result = JSON.stringify(result)


                    localStorage.setItem('user', result)                                        
                })
            }
        })    
        return data
    },

    logout: () => {
        let token = JSON.parse(localStorage.getItem('user')).token

        axios.post(Config.api(`logout?token=${token}`))
        .then((res) => {
            console.log(res)
        })
        .catch((rej) => {
            console.log(rej)
        })
    }
}

export default Auth