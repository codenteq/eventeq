import {Link} from "@inertiajs/react";
import {Toaster} from "react-hot-toast";

const MainLayout = ({ children }) => {
    return (
        <div>
            <Toaster />
            <header className="bg-gray-800 text-white p-4">
                <div className="container mx-auto flex justify-between items-center">
                    <Link href="/public" className="text-lg font-bold">Eventeq</Link>
                    <nav>
                        <Link href="/public" className="mr-4">Home</Link>
                    </nav>
                </div>
            </header>

            <main className="container mx-auto p-4">
                {children}
            </main>

            <footer className="text-gray-600 body-font">
                <div className="container px-5 py-8 mx-auto flex items-center sm:flex-row flex-col">
                    <a className="flex title-font font-medium items-center md:justify-start justify-center text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" strokeLinecap="round"
                             strokeLinejoin="round" strokeWidth="2"
                             className="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                        </svg>
                        <span className="ml-3 text-xl">Codenteq</span>
                    </a>
                    <p className="text-sm text-gray-500 sm:ml-4 sm:pl-4 sm:border-l-2 sm:border-gray-200 sm:py-2 sm:mt-0 mt-4">
                        &#169; 2024.
                    </p>
                    <a href="https://codenteq.com" className="inline-flex sm:ml-auto sm:mt-0 mt-4 justify-center sm:justify-start">
                        Codenteq.com
                    </a>
                </div>
            </footer>
        </div>
    );
};

export default MainLayout;
