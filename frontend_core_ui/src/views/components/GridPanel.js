import React, { useState, useEffect } from "react";

import {
  CCard,
  CCardBody,
  CDataTable,
  CButton,
  CModal,
  CCardHeader,
  CModalBody,
  CModalHeader,
  CModalTitle,
} from "@coreui/react";

export default function GridPanel(props) {

  //State
  const [items, setItems] = useState([]);
  const [showFormModal, setShowFormModal] = useState(false);
  const Form = props.form;

  //Events
  useEffect(onLoad, []);

  //functions
  function onLoad() {
    props.api.get(props.route)
      .then((response) => {
        setItems(response.data);
        console.log(props);
      })
      .catch((response) => {
        console.log(response);
      })
      ;
  }

  async function onCreate() {
    /* const event = { name, date, place, city };
    try {
      await api.post("/admin/events/", event);
      setRequisition(!requisition);
      resetStates();
      setPrimary(!primary);
    } catch (error) {
      console.log(error);
    } */
  }

  //View
  return (
    <>
      <CCard>
        <CCardHeader>
          <CButton color="primary" shape="square" size="md" onClick={() => setShowFormModal(true)}>
            Create Event
          </CButton>
        </CCardHeader>
        <CCardBody>
          <CDataTable
            items={items}
            fields={props.fields}
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
                    >
                      Edit
                    </CButton>
                    <CButton
                      color="danger"
                      variant="ghost"
                      shape="square"
                      size=""
                    >
                      Delete
                    </CButton>
                  </td>
                );
              },
            }}
          />
        </CCardBody>
      </CCard>
      <CModal color="primary" show={showFormModal} onClose={() => setShowFormModal(false)}>
        <CModalHeader closeButton>
          <CModalTitle>Criar</CModalTitle>
        </CModalHeader>
        <CModalBody>
          <Form/>
        </CModalBody>
      </CModal>
    </>
  );
};

