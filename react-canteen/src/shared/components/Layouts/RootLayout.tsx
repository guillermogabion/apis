import React, { useState, useEffect } from 'react';
import Header from '../Partials/Header';
import Footer from '../Partials/Footer';
import SideBar from '../Partials/SideBar';
import { Outlet } from 'react-router-dom';
import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';

const RootLayout = () => {
  const [sidebarOpen, setSidebarOpen] = useState(true);
  const [mainContentClass, setMainContentClass] = useState('col-8');

  const toggleSidebar = () => {
    setSidebarOpen(!sidebarOpen);
  };
  useEffect(() => {
    function handleResize() {
      if (window.innerWidth <= 768) {
        setSidebarOpen(false);
        setMainContentClass('col-12'); // Set the main content to col-12 on mobile screens
      } else {
        setSidebarOpen(true);
        setMainContentClass('col-8'); // Set the main content to col-8 on larger screens
      }
    }

    // Attach event listener for window resize
    window.addEventListener('resize', handleResize);

    // Initial check
    handleResize();

    // Remove event listener on component unmount
    return () => {
      window.removeEventListener('resize', handleResize);
    };
  }, []);
 
  const closeSidebar = () => {
    if (window.innerWidth <= 768) {
      setSidebarOpen(false);
    }
  };

  return (
    <Container fluid>
      <Row>
        <Header toggleSidebar={toggleSidebar} sidebarOpen={sidebarOpen} />
      </Row>
      <Row>
        <div className={`col-md-3 ${sidebarOpen ? 'open' : ''}`}>
          <SideBar sidebarOpen={sidebarOpen} closeSidebar={closeSidebar} />
        </div>
        <div className={`${mainContentClass} ${sidebarOpen ? 'main-content-open col-8' : 'col-12'}`}>
          <Outlet context={{ test: 'test' }} />
        </div>
      </Row>
      <Row>
        <Footer />
      </Row>
    </Container>
  );
};

export default RootLayout;
