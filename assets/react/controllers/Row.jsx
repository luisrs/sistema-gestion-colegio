import React, { useContext } from 'react'
import {RegistroNotasContext} from '../context/RegistroNotasContext'

 function Row({alumno}){

    const {notas, handleInputNota} = useContext(RegistroNotasContext)

    return (
    
    <tr>
        <td>{alumno.nombre} asdada asd</td>
        {notas.map((nota,index)=>{
            if(nota && nota.periodo == 'Primer Semestre'){
                return <>
                <td>
                    <input data-alumno={alumno.id} data-nota={nota.id} data-porcentaje={nota.porcentaje} type="text" onChange={handleInputNota} className="form-control"/>
                    </td>
                <td>
                    <input disabled type="text" className={"form-control " + alumno.id + '_' + nota.id }/>
                </td>
                </>
            }
        })}
        <td><input disabled type="text" onChange={handleInputNota} className={`form-control nota-final-${alumno.id}`}/></td>
       </tr>)
}

export default Row