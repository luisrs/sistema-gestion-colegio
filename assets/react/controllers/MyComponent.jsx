import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';
import axios from 'axios';
import Swal from 'sweetalert2'
import {Table} from './Table';

const root = ReactDOM.createRoot(document.getElementById("root"));

function App(){
    const [cursoAsignatura, setcursoAsignatura] = useState(null);
   
    useEffect(() => {
      const fetchData = async () => {
        try {
          const response = await axios.get('http://localhost/f546/public/index.php/lista-alumnos');
          setcursoAsignatura(response.data);

        } catch (error) {
          console.error(error);
        }
      };
      fetchData();
    }, []);

    return (
        <div className="col-xl-12 col-lg-12">
        <div className="card shadow mb-4">
            <div className="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 className="m-0 font-weight-bold text-primary">  Año - Registro de notas</h6>
            <a href="#" className="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                    className="fas fa-download fa-sm text-white"></i> Descargar PDF</a>
                </div>
                <div className="card-body">
                   {cursoAsignatura ? <Table data={cursoAsignatura}/> : console.log('loading')} 
                </div>
            </div>
    </div>
    )
}



root.render(
    <>
      <App/>
    </>
  );

