import React from "react";
import { useNavigate } from "react-router-dom";
import "./SignIn.css";

const SignIn = () => {
  const navigate = useNavigate();

  const handleSubmit = (e) => {
    e.preventDefault(); // prevent reload
    // Normally you’d check login credentials here
    navigate("/dashboard"); // redirect after "signing in"
  };

  return (
    <div className="signin-container">
      <div className="overlay"></div>
      <div className="signin-card">
        <h2>Welcome Back</h2>
        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <input type="email" placeholder="Email Address" required />
          </div>

          <div className="form-group">
            <input type="password" placeholder="Password" required />
          </div>

          <button type="submit">Sign In</button>
        </form>

        <p className="account-text">
          Don't have an account? <a href="/signup">Sign Up</a>
        </p>
      </div>
    </div>
  );
};

export default SignIn;
