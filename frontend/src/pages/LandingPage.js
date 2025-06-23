import React, { useEffect, useState } from 'react';
import axios from 'axios';
import AOS from 'aos';
import 'aos/dist/aos.css';
import '../styles/landing.less';
import LeftNavbar from '../components/LeftNavbar.jsx';
import CurrencyChart from '../components/CurrencyChart.jsx'; // Assuming you have this component

function LandingPage() {
  const [data, setData] = useState(null);

  useEffect(() => {
    axios.get('http://localhost:8000/api/landing')
      .then(res => setData(res.data))
      .catch(err => console.error(err));
  }, []);

  useEffect(() => {
  AOS.init({
    duration: 1000,
    once: false,   // animate more than once
    mirror: true,  // trigger on scroll-up too
    offset: 120,   // optional: how far from viewport to trigger
  });
}, []);

  if (!data) return <p className="loading">Loading...</p>;

  return (
    <div className="landing-page">

      <LeftNavbar />
      <section className="section hero" id="hero" data-aos="fade-up">
        <h1>{data.title}</h1>
        <p>{data.subtitle}</p>
      </section>

      <section className="section currency-section" id="currency-line" data-aos="fade-up">
        <CurrencyChart chartType="line" />
      </section>

      <section className="section currency-section" id="currency-bar" data-aos="fade-up">
        <CurrencyChart chartType="bar" />
      </section>

      <section className="section footer" id="footer" data-aos="fade-in">
        <p>© {new Date().getFullYear()} Nikhil Singh</p>
      </section>
    </div>
  );
}

export default LandingPage;
