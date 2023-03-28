import React, {useState, useEffect, createContext} from 'react'
import Swal from 'sweetalert2'
import axios from 'axios';
import download from 'downloadjs'



export const RegistroNotasContext = createContext()

export function RegistroNotasContextProvider(props) {

    const [curso, setCurso] = useState([]);
    const [asignatura, setAsignatura] = useState([]);
    const [alumnos, setAlumnos] = useState([]);
    const [notas, setNotas] = useState([]);
   
    useEffect(() => {
      const fetchData = async () => {
        try {
          const response = await axios.get('http://localhost/f546/public/index.php/lista-alumnos');
          setAsignatura(response.data.asignatura);
          setNotas(response.data.notas);
          setCurso(response.data.curso);
          setAlumnos(response.data.alumnos);

        } catch (error) {
          console.error(error);
        }
      };
      fetchData();
    }, []);

    
    // setalumnos({...alumnos,alumno})
    const handleInputNota = (e) =>{
        const notaId = e.target.getAttribute("data-nota")
        const alumnoId = e.target.getAttribute("data-alumno")
        const porcentaje = e.target.getAttribute("data-porcentaje")
        const notaInput = e.target.value
        
        if(isNotaValida(notaInput)){
            const ponderado = Number((notaInput * (porcentaje)/100)).toFixed(1)
            // Se asigna ponderado a input siguiente
            $(`.${alumnoId}_${notaId}`).val(ponderado);
            pintarInputNota(e, notaInput)

            const nuevasNotas = (notas).map(nota =>{
                if(nota.id == notaId){
                    return {...nota, 
                        calificacion : notaInput, 
                        ponderado : ponderado,
                        notaTemplate : notaId
                    }
                }
                return nota
            })
            setNotas(nuevasNotas);

            const alumnoSelected = alumnos.find(alumno => alumno.id == alumnoId);
            alumnoSelected.notas = nuevasNotas;
            // Si se ingresaron todas las notas calcular nota final
            if(alumnoSelected.notas.every(nota => nota.calificacion != null)){
                alumnoSelected.notaFinal = alumnoSelected.notas.reduce((acc,nota) =>{
                    return acc + Number(nota.ponderado)
                },0)
                $(`.nota-final-${alumnoId}`).val(alumnoSelected.notaFinal.toFixed(1))
            }

        // Nota inválida
        }else{
            e.target.value = '';
            $(`.${alumnoId}_${notaId}`).val('');
        }  
    }

    const onSubmit =  (e) =>{
        e.preventDefault()
        try {
          const res =  axios.post('http://localhost/f546/public/index.php/registro-notas', {}, {
            params : {
                alumnos,
                asignatura,
                curso
            }
          } ).then((response)=>{ 
            console.log(response)
            if(response.status){
                Swal.fire({
                    icon: 'success',
                    title: response.msg,
                })
            }else{
                console.log('error');
            }
        })
        //   console.log(res.data)
        } catch (e) {
          alert(e)
        }
    }


    const downLoadScores =  (e) =>{
        e.preventDefault()
        try {
          const res =  axios.post('http://localhost/f546/public/index.php/descargar-notas', {}, {
            params : {
                alumnos
            }
          } ).then((response)=>{ 
            console.log(response)
            const content = response.headers['content-type'];
            download(response.data, 'file_name', content)

            if(response.status){
            console.log('true');
            }else{
                console.log('error');
            }
        })
        //   console.log(res.data)
        } catch (e) {
          alert(e)
        }
    }
    
    function isNotaValida(notaInput){
        if((notaInput <2 || notaInput > 7) && notaInput != ''){
            Swal.fire({
                icon: 'error',
                title: 'Nota incorrecta',
                text: 'Debe estar entre 2 y 7'
            })
            return false;
        }
        return true;
    }

    function pintarInputNota(event, nota){
        if(nota <4){
            event.target.classList.add('is-invalid')
        }else{
            event.target.classList.add('is-valid')
            event.target.classList.remove('is-invalid')
        }

    }

    return (
    <RegistroNotasContext.Provider value={{
        asignatura,
        curso,
        notas,
        alumnos,
        onSubmit,
        handleInputNota,
        downLoadScores
    }}>
        {props.children}
    </RegistroNotasContext.Provider>
    )
}

export default RegistroNotasContext