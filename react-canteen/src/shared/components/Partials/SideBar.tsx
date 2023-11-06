import React, { useState } from 'react';
import { Nav } from 'react-bootstrap';
import { NavLink, useHistory } from 'react-router-dom';
import { useDispatch } from "react-redux";
import { Utility } from '../../../utils';

const SideBar = ({ sidebarOpen, closeSidebar }) => {
  const dispatch = useDispatch();
  const history = useHistory();

  const handleLogout = () => {
    history.push('/login');
    Utility.deleteUserData();
    dispatch({ type: "IS_LOGIN", payload: false });
  };

  return (
    <div className={`collapsible-sidebar ${sidebarOpen ? 'open' : ''}`}>
      <div className='d-flex justify-content-center'>
        {/* Your sidebar content here */}
      </div>
      <Nav defaultActiveKey="/home" className="flex-column sidebar-nav">
        <Nav.Link as={NavLink} to="/" className='sidebar-nav-link' onClick={closeSidebar}>
          Home
        </Nav.Link>
        <Nav.Link as={NavLink} to="/about" className='sidebar-nav-link' onClick={closeSidebar}>
          About
        </Nav.Link>
      </Nav>
      <div className="mt-auto">
        <button onClick={handleLogout}>Logout</button>
      </div>
    </div>
  );
};

export default SideBar;
