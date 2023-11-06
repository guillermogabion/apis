import React from 'react';
import { Route, Routes } from 'react-router-dom';
import AppRoutes from './AppRoutes';

const routes : any = (
    <Routes>
      <Route path="*" element={<AppRoutes />} />
      <Route path="/:someParam/*" element={<AppRoutes />} />
    </Routes>
);

export default routes;