import React from 'react';
import logo from './logo.svg';
import './App.css';

import {
  BrowserRouter as Router,
  Switch,
  Route,
  Link
} from 'react-router-dom'

import Login from './page/Login'

function App()
{
  return (
    <div className="App">
      <Login/>
    </div>
  );
}

export default App;
