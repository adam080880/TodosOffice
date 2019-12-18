import React from 'react'
import {Redirect} from 'react-router-dom'

import Auth from '../../providers/Auth'

export default class LoginForm extends React.Component {    

    constructor(props) {
        super(props)        

        this.state = {
            email: "",
            password: ""
        }

        this.handleChange = this.handleChange.bind(this)
        this.submitForm = this.submitForm.bind(this)        
    }

    componentDidMount() {

    }

    handleChange(e) {
        this.setState({
            [e.target.name]: e.target.value
        })    
    }

    async submitForm(e) {
        e.preventDefault()
        await Auth.login(this.state.email, this.state.password)            

        if(localStorage.getItem('user') !== "" && localStorage.getItem('user') !== "undefined" && window.localStorage.getItem('user') !== null ) {
            console.log("success")
        } else {
            console.log("error")
        }
    }

    render() {
        if(Auth.isAuthenticated()) {
            return (<Redirect to="/"/>)
        }
        return (
            <form onSubmit={this.submitForm}>
                <div>
                    <label>Email</label>
                    <input type="email" name="email" onChange={this.handleChange} val={this.state.email}/>
                </div>
                <div>
                    <label>Password</label>
                    <input type="password" name="password" onChange={this.handleChange} val={this.state.password}/>
                </div>
                <div>
                    <button type="submit">Login</button>                
                </div>
            </form>
        )
    }
}