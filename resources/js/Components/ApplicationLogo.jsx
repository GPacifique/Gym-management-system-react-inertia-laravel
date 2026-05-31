export default function ApplicationLogo(props) {
    return (
        <img
            {...props}
            src="/images/logo.svg"
            alt="Application Logo"
            className={`h-24 w-auto ${props.className || ""}`}
        />
    );
}