import React, { useState } from "react";

import {
    CCol,
    CCardBody,
    CCard,
    CButton,
    CCardFooter,
    CRow,
    CForm,
    CFormGroup,
    CFormText,
    CLabel,
    CInput,
} from "@coreui/react";

import CIcon from '@coreui/icons-react'

export default function EventForm(props) {
    const [name, setName] = useState("");
    const [date, setDate] = useState("");
    const [place, setPlace] = useState("");
    const [city, setcity] = useState("");

    return (
        <CForm action="" method="post">
            <CFormGroup>
                <CLabel htmlFor="name">Name</CLabel>
                <CInput
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                    type="text"
                    name="name"
                    placeholder="Text"
                />
                <CFormText>This is a help text</CFormText>
            </CFormGroup>

            <CFormGroup>
                <CLabel htmlFor="date">Data</CLabel>
                <CInput
                    value={date}
                    onChange={(e) => setDate(e.target.value)}
                    type="date"
                    name="date"
                />
                <CFormText>This is a help text</CFormText>
            </CFormGroup>

            <CFormGroup>
                <CLabel htmlFor="place">Local</CLabel>
                <CInput
                    value={place}
                    onChange={(e) => setPlace(e.target.value)}
                    type="text"
                    name="place"
                />
                <CFormText>This is a help text</CFormText>
            </CFormGroup>

            <CFormGroup>
                <CLabel htmlFor="city">Cidade</CLabel>
                <CInput
                    value={city}
                    onChange={(e) => setcity(e.target.value)}
                    type="text"
                    name="city"
                />
                <CFormText>This is a help text</CFormText>
            </CFormGroup>

            <CFormGroup>
                <CButton type="submit" size="sm" color="primary"><CIcon name="cil-scrubber" /> Salvar</CButton> 
            </CFormGroup>
        </CForm>
    );
};

