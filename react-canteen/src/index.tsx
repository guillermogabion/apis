import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App'
import {BrowserRouter, Routes, Route} from 'react-router-dom'
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min";
// import { createRoot } from "react-dom/client";
import { history } from "./helpers"
import { Provider } from "react-redux"
import store from "./redux/store"
import { saveState } from "./redux/sessionStorage";
import routes from "./routes/index"
import AppRoutes from './routes/AppRoutes';


import "./index.css"



const root = document.getElementById('root');

const createReactRoot = ReactDOM.createRoot(root);


createReactRoot.render(
<Provider store={store}>
      <BrowserRouter>
        <AppRoutes />
      </BrowserRouter>
    </Provider>
)