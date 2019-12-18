import axios from 'axios'
import Config from './Config'

let Auth = {
    isAuthenticated: function() {         
        if(localStorage.getItem('user')) {
            return true
        } else if(localStorage.getItem('user') === 'undefined') {
            return false
        }

        return false

    },

    login: async (email, password) => {        
        await axios.post(Config.api('login'), {
            email: email,
            password: password
        })
        .then(async (res) => {
            if(res.data === "") {
                localStorage.removeItem('user')
            } else {
                localStorage.setItem('user', JSON.stringify({
                    token: res.data.token
                }))                

                await axios.post(Config.api(`me?token=${this.me().token}`))
                .then(async (res) => {
                    let latestToken = this.me()
                    let result = res.data

                    result.token = latestToken.token                    
                    result = JSON.stringify(result)


                    localStorage.setItem('user', result)                                        
                })
            }
        })            
    },

    logout: () => {
        let token = this.me().token

        axios.post(Config.api(`logout?token=${token}`))
        .then((res) => {
            console.log(res)
        })
        .catch((rej) => {
            console.log(rej)
        })
    },

    me: () => {
        return JSON.parse(localStorage.getItem('user'))
    }
}

export default Auth