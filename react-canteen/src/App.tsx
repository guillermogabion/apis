// import React from 'react';
// import { Routes, Route, Link, BrowserRouter, Navigate } from 'react-router-dom';
// import RootLayout from './shared/components/Layouts/RootLayout';
// import Login from './pages/Login/index';
// import Home from './pages/Home';
// import About from './pages/About';
// import Cars from './pages/Cars';
// import CarPage from './pages/Car';
// import AddCarPage from './pages/AddCar';
// import NotFound from './pages/NotFound';
// import CarsLayout from './shared/components/Layouts/CarsLayout';

// const App = () => {
//   return (
//     <>
//         <Route path="/login" element={<Login />} />
//         <Route path="/" element={<RootLayout />}>
//           <Route index element={<Login />} /> {/* Set the index route to Login */}
//           <Route path="/home" element={<Home />} />
//           <Route path="/about" element={<About />} />
//           <Route element={<CarsLayout />}>
//             <Route path="/cars" element={<Cars />} />
//             <Route path="/cars/:id" element={<CarPage />} />
//             <Route path="/cars/add" element={<AddCarPage />} />
//           </Route>
//           <Route path="*" element={<NotFound />} />
//         </Route>
//     </>
//   );
// };

// export default App;
