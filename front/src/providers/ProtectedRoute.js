import React from 'react'
import {Route, Redirect} from 'react-router-dom'

import Auth from './Auth'

function ProtectedRoute({children, ...rest}) {	
	return (
		<Route 
			{...rest}
			render={() => 
				Auth.isAuthenticated() ? (
					children
				) : (
					<Redirect to='/login'/>
				)
			}
		/>
	)
}

export default ProtectedRoute