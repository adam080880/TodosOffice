import React from 'react'

import axios from 'axios'

class Login extends React.Component {

    constructor() {
        super()

        this.state = {
            email: "",
            password: ""
        }

        axios.post("http://localhost:8000/api/test", {
            email: "test",
            password: "test"
        }).then((e) => {
            console.log(e)
        })        
    }

    render() {
        return (        
            <form>

            </form>
        )
    }

}

export default Login;