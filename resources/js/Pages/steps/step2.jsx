import {Button, Input} from "@codenteq/interfeys";
import React, {useEffect, useState} from "react";

export default function Step2({data, setData}) {
    const [participants, setParticipants] = useState([
        { id: 1, full_name: '', birth_date: '' }
    ]);

    const handleParticipantChange = (id, event) => {
        const { name, value } = event.target;
        const updatedParticipants = participants.map(participant => {
            if (participant.id === id) {
                return { ...participant, [name]: value };
            }
            return participant;
        });
        setParticipants(updatedParticipants);
    };

    const handleAddParticipant = () => {
        if (participants.length < 5) {
            const newId = participants.length + 1;
            setParticipants([...participants, { id: newId, full_name: '', birth_date: '' }]);
        }
    };

    const handleRemoveParticipant = (id) => {
        const updatedParticipants = participants.filter(participant => participant.id !== id);
        setParticipants(updatedParticipants);
    };

    useEffect(() => {
        setData('participants', participants);
    }, [participants]);

    return (
        <>
            {participants.map((participant) => (
                <div key={participant.id} className="grid gap-5 mb-6 lg:grid-cols-2 items-center">
                    <Input
                        name={`full_name`}
                        type="text"
                        label={`Katılımcı Tam Adı`}
                        className="block w-full"
                        onChange={(event) => handleParticipantChange(participant.id, event)}
                    />
                    <Input
                        name={`birth_date`}
                        type="date"
                        label={`Katılımcı Doğum Tarihi`}
                        className="block w-full"
                        onChange={(event) => handleParticipantChange(participant.id, event)}
                    />
                    {participants.length > 1 && (
                        <div className="flex items-center">
                            <button type="button" className="text-left text-red-600" onClick={() => handleRemoveParticipant(participant.id)}>
                                Sil
                            </button>
                        </div>
                    )}
                </div>
            ))}
            {participants.length < 5 && (
                <div className="flex justify-end mb-6">
                    <Button type="button" label="Katılımcı Ekle" onClick={handleAddParticipant} />
                </div>
            )}
        </>
    )
}
