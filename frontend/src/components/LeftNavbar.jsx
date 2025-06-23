import React from 'react';
  import '../styles/left-navbar.less';

const sections = [
  { id: 'hero', label: 'Home' },
  { id: 'currency-line', label: 'Live AUD Exchange Rates (Line)' },
  { id: 'currency-bar', label: 'Live AUD Exchange Rates (Histogram)' },
  { id: 'footer', label: 'Footer' }
];

function LeftNavbar() {
  return (
    <nav className="left-navbar">
      <ul>
        {sections.map((section) => (
          <li key={section.id}>
            <a href={`#${section.id}`}>{section.label}</a>
          </li>
        ))}
      </ul>
    </nav>
  );
}

export default LeftNavbar;