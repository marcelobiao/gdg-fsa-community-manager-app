import React from "react";

import api from "../../services/api";
import _form from "./_form";
import GridPanel from "../components/GridPanel";

export default function People(props){
  const route = "/admin/people";
  const fields = ["id","email","name","about","import_id"];

  return (
    <>
      <GridPanel 
        api={api}
        route={route}
        fields={fields}
      />
    </>
  );
};