//import hook useState from react
import React, { useState, useEffect } from "react";

//import layout
import LayoutAdmin from "../../../layouts/Admin";

//import BASE URL API
import Api from "../../../api";

//import hook navigate dari react router dom
import { useNavigate, useParams } from "react-router-dom";

//import js cookie
import Cookies from "js-cookie";

//import toats
import toast from "react-hot-toast";

function UserEdit() {

    //title page
    document.title = "Edit User - Administrator Travel GIS";

    //state
    const [Nama, setNama] = useState("");
    const [username, setUsername] = useState("");
    const [levelakses, setLevelakses] = useState("");
    const [password, setPassword] = useState("");
    const [passwordConfirmation, setPasswordConfirmation] = useState("");

    //state validation
    const [validation, setValidation] = useState({});

    //token
    const token = Cookies.get("token");

    //navigate
    const navigate = useNavigate();

    //get ID from parameter URL
    const { id } = useParams();

    //function "getUserById"
    const getUserById = async () => {

        //get data from server
        const response = await Api.get(`/api/admin/users/${id}`, {

            //header
            headers: {
                //header Bearer + Token
                Authorization: `Bearer ${token}`,
            }
        });

        //get response data
        const data = await response.data.data

        //assign data to state "name"
        setNama(data.Nama);
        //assign data to state "email"
        setUsername(data.username);
        setLevelakses(data.levelakses);
    };

    //hook useEffect
    useEffect(() => {

        //panggil function "getUserById"
        getUserById();

        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);

    //function "updateUser"
    const updateUser = async (e) => {
        e.preventDefault();

        //define formData
        const formData = new FormData();

        //append data to "formData"
        formData.append('Nama', Nama);
        formData.append('username', username);
        formData.append('password', password);
        formData.append('levelakses', levelakses);
        formData.append('password_confirmation', passwordConfirmation);
        formData.append('_method', 'PATCH');

        await Api.post(`/api/admin/users/${id}`, formData, {

                //header
                headers: {
                    //header Bearer + Token
                    Authorization: `Bearer ${token}`,
                }

            }).then(() => {

                //show toast
                toast.success("Data Updated Successfully!", {
                    duration: 4000,
                    position: "top-right",
                    style: {
                        borderRadius: '10px',
                        background: '#333',
                        color: '#fff',
                    },
                });

                //redirect dashboard page
                navigate("/admin/users");

            })
            .catch((error) => {

                //set state "validation"
                setValidation(error.response.data);
            })

    }

    return (
        <React.Fragment>
            <LayoutAdmin>
                <div className="row mt-4">
                    <div className="col-12">
                        <div className="card border-0 rounded shadow-sm border-top-success">
                            <div className="card-header">
                                <span className="font-weight-bold"><i className="fa fa-users"></i> EDIT USER</span>
                            </div>
                            <div className="card-body">
                                <form onSubmit={updateUser}>

                                    <div className="row">
                                        <div className="col-md-6">
                                            <div className="mb-3">
                                                <label className="form-label fw-bold">Full Name</label>
                                                <input type="text" className="form-control" value={Nama} onChange={(e) => setNama(e.target.value)} placeholder="Enter Full Name"/>
                                            </div>
                                            {validation.Nama && (
                                                <div className="alert alert-danger">
                                                    {validation.Nama[0]}
                                                </div>
                                            )}
                                        </div>
                                        <div className="col-md-6">
                                            <div className="mb-3">
                                                <label className="form-label fw-bold">Email Address</label>
                                                <input type="text" className="form-control" value={username} onChange={(e) => setUsername(e.target.value)} placeholder="Enter Username"/>
                                            </div>
                                            {validation.username && (
                                                <div className="alert alert-danger">
                                                    {validation.username[0]}
                                                </div>
                                            )}
                                        </div>
                                        <div className="col-md-6">
                                            <div className="mb-3">
                                                <label className="form-label fw-bold">Level Akses</label>
                                                <input type="text" className="form-control" value={levelakses} onChange={(e) => setLevelakses(e.target.value)} placeholder="Enter Level Akses"/>
                                            </div>
                                            {validation.levelakses && (
                                                <div className="alert alert-danger">
                                                    {validation.levelakses[0]}
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                    

                                    <div className="row">
                                        <div className="col-md-6">
                                            <div className="mb-3">
                                                <label className="form-label fw-bold">Password</label>
                                                <input type="text" className="form-control" value={password} onChange={(e) => setPassword(e.target.value)} placeholder="Enter Password"/>
                                            </div>
                                            {validation.password && (
                                                <div className="alert alert-danger">
                                                    {validation.password[0]}
                                                </div>
                                            )}
                                        </div>
                                        <div className="col-md-6">
                                            <div className="mb-3">
                                                <label className="form-label fw-bold">Password Confirmation</label>
                                                <input type="text" className="form-control" value={passwordConfirmation} onChange={(e) => setPasswordConfirmation(e.target.value)} placeholder="Enter Password Confirmation"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <button type="submit" className="btn btn-md btn-success me-2"><i className="fa fa-save"></i> UPDATE</button>
                                        <button type="reset" className="btn btn-md btn-warning"><i className="fa fa-redo"></i> RESET</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
              </div>
            </LayoutAdmin>
        </React.Fragment>
    );
}

export default UserEdit;