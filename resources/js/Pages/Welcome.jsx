import {Link} from "@inertiajs/react";
import {Button} from "@codenteq/interfeys";
import MainLayout from "../Layouts/MainLayout.jsx";

export default function Welcome({events}) {
    console.log(events)
    return (
        <>
            <MainLayout>
                <section className="text-gray-600 body-font">
                    <div className="container px-5 py-24 mx-auto">
                        <div className="text-center w-full mb-10">
                            <h1 className="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">
                                Öne Çıkan Etkinlikler
                            </h1>
                        </div>
                        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            {events.map((event) => (
                                <div
                                    key={event.id}
                                    className="flex flex-col max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                    <Link href={`/events/${event.id}`} className="flex-shrink-0">
                                        <img className="rounded-t-lg w-full" src={`storage/${event.img}`}
                                             alt={event.name}/>
                                    </Link>
                                    <div className="flex flex-col flex-grow p-5">
                                        <Link href={`/events/${event.id}`} className="mb-2">
                                            <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                                {event.name}
                                            </h5>
                                        </Link>
                                        <div className="flex-grow">
                                            <p className="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                                📍{event?.city?.name}
                                            </p>
                                        </div>
                                        <Link href={`/events/${event.id}`} className="mt-3">
                                            <Button type="button" label="Etkinliği incele" className="w-full"/>
                                        </Link>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>
            </MainLayout>
        </>
    )
}
