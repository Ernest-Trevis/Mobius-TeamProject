import React from "react";
import { BrowserRouter, Routes, Route, Navigate } from "react-router-dom";
import SignUp from "./components/SignUp";
import SignIn from "./components/SignIn";

function App() {
  return (
    <BrowserRouter>
      <Routes>
        {/* Default route */}
        <Route index element={<Navigate to="/signin" replace />} />

        {/* Main routes */}
        <Route path="/signup" element={<SignUp />} />
        <Route path="/signin" element={<SignIn />} />

        {/* Temporary dashboard page */}
        <Route
          path="/dashboard"
          element={<h1 style={{ textAlign: "center", marginTop: "2rem" }}>Welcome to Dashboard</h1>}
        />

        {/* Fallback route */}
        <Route
          path="*"
          element={<h1 style={{ textAlign: "center", marginTop: "2rem" }}>404 Page Not Found</h1>}
        />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
