import {Button, Input} from "@codenteq/interfeys";
import React, {useState} from "react";

export default function Step2({ onNext, onPrev }) {
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

    const handlePrevClick = () => {
        console.log('Önceki butona tıklandı!');
        onPrev();
    };

    const handleNextClick = () => {
        console.log('Sonraki butona tıklandı!');
        onNext();
    };

    return (
        <>
            {participants.map((participant) => (
                <div key={participant.id} className="grid gap-5 mb-6 lg:grid-cols-2 items-center">
                    <Input
                        name={`full_name_${participant.id}`}
                        type="text"
                        label={`Katılımcı ${participant.id} Tam Adı`}
                        className="block w-full"
                        onChange={(event) => handleParticipantChange(participant.id, event)}
                    />
                    <Input
                        name={`birth_date_${participant.id}`}
                        type="date"
                        label={`Katılımcı ${participant.id} Doğum Tarihi`}
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
            <div className="flex items-center justify-between">
                <button type="button" onClick={handlePrevClick} className="mr-2">
                    Önceki
                </button>
                <Button type="submit" label="Sonraki" onClick={handleNextClick}/>
            </div>
        </>
    )
}
