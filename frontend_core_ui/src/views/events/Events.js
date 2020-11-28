import React, { useState, useEffect } from "react";

import {
  CCard,
  CCardBody,
  CDataTable,
  CButton,
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
  CInput,
} from "@coreui/react";

import api from "../../services/api";

const fields = ["id", "name", "date", "place", "city", "actions"];

export default function Events(props) {
  const [events, setEvents] = useState([]);
  const [id, setId] = useState("");
  const [name, setName] = useState("");
  const [date, setDate] = useState("");
  const [place, setPlace] = useState("");
  const [city, setcity] = useState("");
  const [primary, setPrimary] = useState(false);
  const [secondary, setSecondary] = useState(false);
  const [requisition, setRequisition] = useState(false);

  const resetStates = () => {
    setId("");
    setName("");
    setDate("");
    setPlace("");
    setcity("");
  }

  async function handleCreateEvent() {
    const event = { name, date, place, city };
    try {
      await api.post("/admin/events/", event);
      setRequisition(!requisition);
      resetStates();
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

  const openEditEventModal = ({ id, name, date, place, city }) => {
    setSecondary(!secondary);
    var data = date.replace("00:00:00", "");
    data = data.replace(" ", "")
    setId(id);
    setName(name);
    setDate(data);
    setPlace(place);
    setcity(city);
  }

  const editEvent = async () => {
    const event = { name, date, place, city };

    try {
      await api.put(`/admin/events/${id}`, event);
      console.log("editado com sucesso");
      resetStates();
      setRequisition(!requisition);
    } catch (error) {
      console.log("erro")
    }
    setSecondary(!secondary);
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
            size="md"
            onClick={() => setPrimary(!primary)}
          >
            Create Event
            </CButton>
        </CCardHeader>

        <CCardBody>
          <CDataTable
            items={events}
            fields={fields}
            columnFilter
            tableFilter
            hover
            striped
            bordered
            size="lg"
            itemsPerPage={10}
            sorter
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
                        openEditEventModal(item);
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
                  <CLabel htmlFor="text-input">Nome</CLabel>
                </CCol>
                <CCol xs="12" md="9">
                  <CInput
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                    type="text"
                    name="text-input"
                  />
                  <CFormText>This is a help text</CFormText>
                </CCol>
              </CFormGroup>

              <CFormGroup row>
                <CCol md="3">
                  <CLabel htmlFor="date-input">Data do evento</CLabel>
                </CCol>
                <CCol xs="12" md="9">
                  <CInput
                    value={date}
                    onChange={(e) => setDate(e.target.value)}
                    type="date"
                    name="date-input"
                  />
                </CCol>
              </CFormGroup>

              <CFormGroup row>
                <CCol md="3">
                  <CLabel htmlFor="text-input">Local</CLabel>
                </CCol>
                <CCol xs="12" md="9">
                  <CInput
                    value={place}
                    onChange={(e) => setPlace(e.target.value)}
                    type="text"
                    name="text-input"
                  />
                  <CFormText>This is a help text</CFormText>
                </CCol>
              </CFormGroup>

              <CFormGroup row>
                <CCol md="3">
                  <CLabel htmlFor="text-input">Cidade</CLabel>
                </CCol>
                <CCol xs="12" md="9">
                  <CInput
                    value={city}
                    onChange={(e) => setcity(e.target.value)}
                    type="text"
                    name="text-input"
                  />
                  <CFormText>This is a help text</CFormText>
                </CCol>
              </CFormGroup>
            </CForm>
          </CModalBody>
          <CModalFooter>
            <CButton color="primary" onClick={handleCreateEvent}>
              Criar Evento
            </CButton>
            <CButton color="secondary" onClick={() => setPrimary(!primary)}>
              Cancel
            </CButton>
          </CModalFooter>
        </CModal>
        <CModal
          show={secondary}
          onClose={() => setSecondary(!secondary)}
          color="primary"
        >
          <CModalHeader closeButton>
            <CModalTitle>Editar</CModalTitle>
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
                  <CLabel htmlFor="date-input">Data do Evento</CLabel>
                </CCol>
                <CCol xs="12" md="9">
                  <CInput
                    value={date}
                    onChange={(e) => setDate(e.target.value)}
                    type="date"
                    name="date-input"
                  />
                </CCol>
              </CFormGroup>

              <CFormGroup row>
                <CCol md="3">
                  <CLabel htmlFor="text-input">Local</CLabel>
                </CCol>
                <CCol xs="12" md="9">
                  <CInput
                    value={place}
                    onChange={(e) => setPlace(e.target.value)}
                    type="text"
                    name="text-input"
                  />
                  <CFormText>This is a help text</CFormText>
                </CCol>
              </CFormGroup>

              <CFormGroup row>
                <CCol md="3">
                  <CLabel htmlFor="text-input">Cidade</CLabel>
                </CCol>
                <CCol xs="12" md="9">
                  <CInput
                    value={city}
                    onChange={(e) => setcity(e.target.value)}
                    type="text"
                    name="text-input"
                  />
                  <CFormText>This is a help text</CFormText>
                </CCol>
              </CFormGroup>
            </CForm>
          </CModalBody>
          <CModalFooter>
            <CButton color="primary" onClick={editEvent}>Edit</CButton>
            <CButton color="secondary" onClick={() => setSecondary(!secondary)}>
              Cancel
            </CButton>
          </CModalFooter>
        </CModal>
      </CCard>
    </>
  );
};