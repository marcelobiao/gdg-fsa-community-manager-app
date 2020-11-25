import React, { useState, useEffect } from 'react'
import {
  CCard,
  CCardBody,
  CDataTable,
} from '@coreui/react'

import api from '../../services/api'

const fields = ['id', 'name', 'date', 'place', 'city']

const Events = () => {

  const [events, setEvents] = useState([]);

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
          />
        </CCardBody>
      </CCard>
    </>
  )
}

export default Events
