import React, { useEffect } from 'react';
import { Routes, Route, Navigate } from 'react-router-dom';
import RootLayout from '../shared/components/Layouts/RootLayout';
import Login from '../pages/Login/index';
import Home from '../pages/Home';
import About from '../pages/About';
import Cars from '../pages/Cars';
import CarPage from '../pages/Car';
import AddCarPage from '../pages/AddCar';
import NotFound from '../pages/NotFound';
import CarsLayout from '../shared/components/Layouts/CarsLayout';
import { useSelector, useDispatch } from 'react-redux';
import { AES, enc } from 'crypto-js';
import { Utility } from '../utils';

const AppRoutes = () => {
  const dispatch = useDispatch();
  const { data } = useSelector((state: any) => state.rootReducer.userData);

  const encryptionKey = process.env.REACT_APP_ENCRYPTION_KEY || '';
  const access_token = localStorage.getItem('access_token'); // Retrieve access_token from localStorage

  useEffect(() => {
    const bootstrapAsync = async () => {
      Utility.startResetTokenTimer();
      Utility.refreshTokenProcess();
      dispatch({ type: "IS_LOGIN", payload: true })
    };
    bootstrapAsync();
  }, [dispatch]);

  const isUserLoggedIn = () => {
    const isLogin = useSelector((state: RootState) => state.rootReducer.isLogin);
    return isLogin;
  };

  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      {/* <Route path="/logout" element={<Logout />} /> Make sure to import Logout */}
      <Route element={<RootLayout />}>
        <Route exact element={<Home />} /> {/* Handles both "/" and "/home" */}
        <Route path="/about" element={<About />} />
        <Route element={<CarsLayout />}>
          <Route path="/cars" element={<Cars />} />
          <Route path="/cars/:id" element={<CarPage />} />
          <Route path="/cars/add" element={<AddCarPage />} />
        </Route>
        <Route path="*" element={isUserLoggedIn() && <NotFound />} />
      </Route>
    </Routes>
  );
};

export default AppRoutes;






// import React, { useEffect } from 'react';
// import { Routes, Route, Navigate } from 'react-router-dom';
// import RootLayout from '../shared/components/Layouts/RootLayout';
// import Login from '../pages/Login/index';
// import Logout from '../pages/Logout/index';
// import Home from '../pages/Home';
// import About from '../pages/About';
// import Cars from '../pages/Cars';
// import CarPage from '../pages/Car';
// import AddCarPage from '../pages/AddCar';
// import NotFound from '../pages/NotFound';
// import CarsLayout from '../shared/components/Layouts/CarsLayout';
// import { RootState } from '../redux/reducers';
// import { useSelector, useDispatch } from 'react-redux';
// import { AES, enc } from 'crypto-js';
// import { Utility } from '../utils';
// // import jwt_decode from 'jwt-decode'; 

// const isUserLoggedIn = () => {
//   const isLogin = useSelector((state: RootState) => state.rootReducer.isLogin);
//   return isLogin;
// };

// const AppRoutes: React.FunctionComponent = (props) => {
//   const dispatch = useDispatch();
//   const { data } = useSelector((state: any) => state.rootReducer.userData);
//   let pathList: any = [];
//   let currentPath = '';

//   const encryptionKey = process.env.REACT_APP_ENCRYPTION_KEY || '';

//   const currentRoutePath = useSelector((state: any) => state.rootReducer.currentRoutePath);
//   const isLogin = useSelector((state: any) => state.rootReducer.isLogin);
//   const originalUser = AES.decrypt(localStorage.getItem('_as175errepc') || '', encryptionKey).toString(enc.Utf8);

//   // Extract the access_token from your data structure
//   const access_token = data.access_token;

//   // Decode the access_token
// //   const decoded = jwt_decode(access_token);

//   useEffect(() => {
//     const bootstrapAsync = async () => {
//         Utility.startResetTokenTimer();
//         Utility.refreshTokenProcess();
//     };
//     bootstrapAsync();
//   }, [dispatch, isLogin]);

//   return (
//     <Routes>
//       <Route path="/login" element={isUserLoggedIn() ? <Navigate to="/" /> : <Login />} />
//       <Route path="/logout" element={<Logout />} />
//       <Route element={isUserLoggedIn() ? <RootLayout /> : <Navigate to="/login" />}>
//         <Route index element={<Home />} /> {/* Handles both "/" and "/home" */}
//         <Route path="/about" element={<About />} />
//         <Route element={<CarsLayout />}>
//           <Route path="/cars" element={<Cars />} />
//           <Route path="/cars/:id" element={<CarPage />} />
//           <Route path="/cars/add" element={<AddCarPage />} />
//         </Route>
//         <Route path="*" element={<NotFound />} />
//       </Route>
//     </Routes>
//   );
// };

// export default React.memo(AppRoutes)

