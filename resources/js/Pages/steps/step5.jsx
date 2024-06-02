import {Button, Input} from "@codenteq/interfeys";
import React from "react";

export default function Step5({data, setData, event}) {

    return (
        <>
            <div className="grid gap-5 mb-6 lg:grid-cols-2">
                <Input
                    name="arrival_date"
                    value={data.arrival_date}
                    onChange={(e) => setData('arrival_date', e.target.value)}
                    type="date"
                    min={event.start_date}
                    max={event.end_date}
                    label="Varış tarihi"
                    className="block w-full"
                    required
                />
                <Input
                    name="departure_date"
                    value={data.departure_date}
                    onChange={(e) => setData('departure_date', e.target.value)}
                    type="date"
                    min={event.start_date}
                    max={event.end_date}
                    required
                    label="Ayrılış tarihi"
                    className="block w-full"
                />
            </div>
        </>
    )
}
