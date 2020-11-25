import React, { useState, useEffect } from 'react'

import {
  CCard,
  CCardBody,
  CDataTable,
  CButton,
  CRow,
  CCol,
} from '@coreui/react'

import api from '../../services/api'

const fields = ['id', 'name', 'date', 'place', 'city','actions'];


const editEvent = (index) => {
  
}


const Events = () => {

  const [events, setEvents] = useState([]);

  const deleteEvent = (index) => {
    api.delete(`/admin/events/${index}`).then(response=>{
     setEvents(events.filter((event)=>{
       return event.id!==index;
     }))
    }).catch(response=>{
      console.log(response);
    })
   }

  useEffect(() => {
    api.get('/admin/events')
      .then(response => {
        console.log(response);
        setEvents(response.data);
      }).catch(response => {
        console.log(response);
      })
  }, []);

  return (
    <>
      <CCard>
        <CCardBody>
          <CDataTable
            items={events}
            fields={fields}
            hover
            striped
            bordered
            size="lg"
            itemsPerPage={10}
            pagination
            scopedSlots ={{
              'actions':
              (item, index)=>{
                return (
                  <td  >
                    <CButton
                      
                      color="primary"
                      variant="ghost"
                      shape="square"
                      size=""
                      onClick={()=>{editEvent(item.id)}}
                    >
                      Edit
                    </CButton>
                    <CButton
                      color="danger"
                      variant="ghost"
                      shape="square"
                      size=""
                      onClick={()=>{deleteEvent(item.id)}}
                    >
                      Delete
                    </CButton>
                  </td>
                  )
              },
            }}
          />
        </CCardBody>
                  <CRow className="mx-auto" style={{width:"200px"}}>
                    <CCol col="12"  >
                     <CButton
                      color="success"
                     
                      shape="square"
                      size="sm"
                      
                    >
                      Create Event
                    </CButton>
                    </CCol >
                 </CRow >
      </CCard>
    </>
  )
}

export default Events
