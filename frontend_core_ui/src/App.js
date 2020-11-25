import React, { Component } from 'react';
import { HashRouter,Router} from 'react-router-dom';
import Routes from './Routes/routes'
import history from './utils/history'
import './scss/style.scss';

const loading = (
  <div className="pt-3 text-center">
    <div className="sk-spinner sk-spinner-pulse"></div>
  </div>
)





class App extends Component {

  render() {
    return (
      <HashRouter>
          <React.Suspense fallback={loading}>
            <Router history={history}>
               <Routes/>
            </Router>
          </React.Suspense>
      </HashRouter>
    );
  }
}

export default App;
