import React, { useState, useEffect } from 'react'
import {
  CBadge,
  CCard,
  CCardBody,
  CCardHeader,
  CCol,
  CDataTable,
  CRow
} from '@coreui/react'

import api from '../../services/api'

const getBadge = status => {
  switch (status) {
    case 'Active': return 'success'
    case 'Inactive': return 'secondary'
    case 'Pending': return 'warning'
    case 'Banned': return 'danger'
    default: return 'primary'
  }
}

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
      <CRow>
        <CCol>
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
        </CCol>
      </CRow>
    </>
  )
}

export default Events
