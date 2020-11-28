import React from "react";

import api from "../../services/api";
import GridPanel from "../components/GridPanel";
import _form from "./_form";

export default function Events(props){
  const route = "/admin/events";
  const fields = ["id", "name", "date", "place", "city", "actions"];

  return (
    <>
      <GridPanel 
        api={api}
        route={route}
        fields={fields}
        form={_form}
      />
    </>
  );
};