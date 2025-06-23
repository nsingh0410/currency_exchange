describe('Landing Page E2E Test', () => {
  beforeEach(() => {
    cy.visit('http://localhost:3000');
  });

  it('displays loading and then content', () => {
    cy.contains('Loading...'); // Initial state
    cy.get('.landing-page', { timeout: 10000 }).should('exist');
  });

  it('loads API data and displays title and subtitle', () => {
    cy.get('#hero').within(() => {
      cy.get('h1').should('not.be.empty');
      cy.get('p').should('not.be.empty');
    });
  });

  it('renders the currency charts', () => {
    cy.get('#currency-line').scrollIntoView().should('be.visible');
    cy.get('#currency-bar').scrollIntoView().should('be.visible');
  });

  it('renders the navbar and navigates to sections', () => {
    cy.get('.left-navbar a').should('have.length', 4);

    cy.get('.left-navbar a').each((link) => {
      cy.wrap(link).click();
      cy.url().should('include', `#${link.attr('href').replace('#', '')}`);
    });
  });

  it('displays the footer with year and name', () => {
    const year = new Date().getFullYear();
    cy.get('#footer').scrollIntoView().should('contain', `© ${year} Nikhil Singh`);
  });
});
