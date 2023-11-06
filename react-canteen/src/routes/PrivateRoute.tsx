import React from 'react';
import { Route, Navigate } from 'react-router-dom';

const PrivateRoute = ({ element, isUserLoggedIn, redirectTo }) => {
  return isUserLoggedIn ? element : <Navigate to={redirectTo} />;
};

export default PrivateRoute;
