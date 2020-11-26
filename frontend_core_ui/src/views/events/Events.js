import React, { useState, useEffect } from "react";

import {
  CCard,
  CCardBody,
  CDataTable,
  CButton,
  CRow,
  CCol,
  CModal,
  CCardHeader,
  CModalBody,
  CModalFooter,
  CModalHeader,
  CModalTitle,
  CForm,
  CFormGroup,
  CFormText,
  CLabel,
  CTextarea,
  CInput,
} from "@coreui/react";

import api from "../../services/api";

const fields = ["id", "name", "date", "place", "city", "actions"];

const editEvent = (index) => { };

const Events = () => {
  const [events, setEvents] = useState([]);
  const [name, setName] = useState("");
  const [date, setDate] = useState("");
  const [place, setPlace] = useState("");
  const [city, setcity] = useState("");
  const [primary, setPrimary] = useState(false);
  const [requisition, setRequisition] = useState(false);

  async function handleCreateEvent(e) {
    e.preventDefault();

    const event = { name, date, place, city };

    try {
      await api.post("/admin/events/", event);
      setRequisition(!requisition);
      setPrimary(!primary);
    } catch (error) {
      console.log(error);
    }
  }

  const deleteEvent = (index) => {
    api
      .delete(`/admin/events/${index}`)
      .then(() => {
        setEvents(
          events.filter((event) => {
            return event.id !== index;
          })
        );
      })
      .catch((response) => {
        console.log(response);
      });
  };

  useEffect(() => {
    api
      .get("/admin/events")
      .then((response) => {
        console.log(response);
        setEvents(response.data);
      })
      .catch((response) => {
        console.log(response);
      });
  }, [requisition]);

  return (
    <>
      <CCard>
        <CCardHeader>
          <CButton
            color="primary"
            shape="square"
            size="sm"
            onClick={() => setPrimary(!primary)}
          >
            Create Event
            </CButton>
        </CCardHeader>

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
            scopedSlots={{
              actions: (item, index) => {
                return (
                  <td>
                    <CButton
                      color="primary"
                      variant="ghost"
                      shape="square"
                      size=""
                      onClick={() => {
                        editEvent(item.id);
                      }}
                    >
                      Edit
                    </CButton>
                    <CButton
                      color="danger"
                      variant="ghost"
                      shape="square"
                      size=""
                      onClick={() => {
                        deleteEvent(item.id);
                      }}
                    >
                      Delete
                    </CButton>
                  </td>
                );
              },
            }}
          />
        </CCardBody>

        <CModal
          show={primary}
          onClose={() => setPrimary(!primary)}
          color="primary"
        >
          <CModalHeader closeButton>
            <CModalTitle>Create</CModalTitle>
          </CModalHeader>
          <CModalBody>
            <CForm>
              <CFormGroup row>
                <CCol md="3">
                  <CLabel htmlFor="text-input">Name</CLabel>
                </CCol>
                <CCol xs="12" md="9">
                  <CInput
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                    type="text"
                    name="text-input"
                    placeholder="Text"
                  />
                  <CFormText>This is a help text</CFormText>
                </CCol>
              </CFormGroup>

              <CFormGroup row>
                <CCol md="3">
                  <CLabel htmlFor="date-input">Date</CLabel>
                </CCol>
                <CCol xs="12" md="9">
                  <CInput
                    value={date}
                    onChange={(e) => setDate(e.target.value)}
                    type="date"
                    name="date-input"
                    placeholder="date"
                  />
                </CCol>
              </CFormGroup>

              <CFormGroup row>
                <CCol md="3">
                  <CLabel htmlFor="text-input">Place</CLabel>
                </CCol>
                <CCol xs="12" md="9">
                  <CInput
                    value={place}
                    onChange={(e) => setPlace(e.target.value)}
                    type="text"
                    name="text-input"
                    placeholder="Text"
                  />
                  <CFormText>This is a help text</CFormText>
                </CCol>
              </CFormGroup>

              <CFormGroup row>
                <CCol md="3">
                  <CLabel htmlFor="text-input">City</CLabel>
                </CCol>
                <CCol xs="12" md="9">
                  <CInput
                    value={city}
                    onChange={(e) => setcity(e.target.value)}
                    type="text"
                    name="text-input"
                    placeholder="Text"
                  />
                  <CFormText>This is a help text</CFormText>
                </CCol>
              </CFormGroup>
            </CForm>
          </CModalBody>
          <CModalFooter>
            <CButton color="primary" onClick={handleCreateEvent}>
              Create
            </CButton>
            <CButton color="secondary" onClick={() => setPrimary(!primary)}>
              Cancel
            </CButton>
          </CModalFooter>
        </CModal>
      </CCard>
    </>
  );
};

export default Events;
