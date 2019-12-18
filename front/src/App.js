import React from 'react';
import './App.css';
import ProtectedRoute from './providers/ProtectedRoute'
import {BrowserRouter, Route, Switch} from 'react-router-dom'

import LoginForm from './page/auth/LoginForm'

function App() {		
	return (
		<BrowserRouter>
			<Switch>
				<ProtectedRoute exact path="/">
					<p>Test</p>
				</ProtectedRoute>
				<Route exact path="/login">
					<LoginForm/>
				</Route>
				<Route path="*">
					Error 404 [PAGE IS NOT FOUND]
				</Route>
			</Switch>
		</BrowserRouter>
	);
}

export default App;
