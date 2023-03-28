import React, { useState, useEffect, useContext } from 'react';
import ReactDOM from 'react-dom/client';
import {Table} from './Table';
import { RegistroNotasContextProvider, RegistroNotasContext } from '../context/RegistroNotasContext';

const root = ReactDOM.createRoot(document.getElementById("root"));

function App(){

    const {downLoadScores} = useContext(RegistroNotasContext)
   
    return (
        <div className="col-xl-12 col-lg-12">
        <div className="card shadow mb-4">
            <div className="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 className="m-0 font-weight-bold text-primary">  Año - Registro de notas</h6>
            
            <button onClick={downLoadScores} className="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i className="fas fa-download fa-sm text-white"></i> Descsargar PDF</button>
            </div>
                <div className="card-body">
                   <Table/>
                </div>
            </div>
    </div>
    )
}

root.render(
    <React.StrictMode>  
      <RegistroNotasContextProvider>
        <App/>
      </RegistroNotasContextProvider>
    </React.StrictMode>  
  );

